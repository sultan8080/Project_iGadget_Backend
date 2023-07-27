import { LockClosedIcon } from "@heroicons/react/solid";
import { Field, Form, Formik, ErrorMessage } from "formik";
import React, { useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Link, useNavigate } from "react-router-dom";
import * as Yup from "yup";
import { toast } from "react-toastify";

import {
  URL_ADMIN_HOME,
  URL_DASHBOARD_ADMIN,
  URL_PROFILE,
} from "../../constants/urls/urlFrontEnd";
import {
  selectHasRole,
  signIn,
  selectIsLogged,
} from "../../redux-store/authenticationSlice";
import { authenticate } from "./../../api/backend/account";
import { ROLE_ADMIN, ROLE_USER } from "../../constants/rolesConstant";

/**
 * Component Login
 *
 */
const Login = () => {
  const [errorLog, setErrorLog] = useState(false);

  const isUser = useSelector((state) => selectHasRole(state, ROLE_USER));
  const isAdmin = useSelector((state) => selectHasRole(state, ROLE_ADMIN));
  const isLoggedIn = useSelector(selectIsLogged);
  
  const dispatch = useDispatch();
  const navigate = useNavigate();

  const handleLogin = (values) => {
    authenticate(values)
      .then((res) => {
        if (res.status === 200 && res.data.token) {
          dispatch(signIn(res.data.token));
          toast.success("Connexion réussie ! Bienvenue à bord!", {
            position: toast.POSITION.TOP_CENTER,
          });
          if (isAdmin) {
            navigate(URL_DASHBOARD_ADMIN);
          } else if (isUser) {
            navigate(URL_PROFILE);
          }
        }
      })
      .catch(function (error) {
        console.log(error);
        toast.error("Identifiant/Mot de passe incorrect(s)", {
          position: toast.POSITION.TOP_CENTER,
        });
      });
  };

  return (
    <div className="w-full max-w-md space-y-4 rounded-md bg-white p-4 py-12 px-4 shadow-lg sm:px-6 lg:px-8">
      <div className="text-center">
        <h2 className="mt-1 text-center text-3xl font-bold text-primary">
          CONNEXION
        </h2>
        <small className="text-center">
          Inscrivez-vous pour ne plus passer à côté des occasions
        </small>
      </div>

      <hr />

      <Formik
        initialValues={{
          username: "",
          password: "",
        }}
        validationSchema={Yup.object({
          username: Yup.string()
            .email("Adresse e-mail invalide")
            .required("Email Obligatoire"),
          password: Yup.string().required("Mot de passe obligatoire"),
        })}
        onSubmit={handleLogin}
      >
        <Form className="mt-5 space-y-6">
          <div className="flex flex-col space-y-3 rounded-md shadow-sm">
            <Field
              type="text"
              name="username"
              placeholder="Votre email"
              className="input"
            />
            <small className="text-red-600">
              <ErrorMessage name="username" />
            </small>
            <Field
              type="password"
              name="password"
              placeholder="votre mot de passe"
              className="input"
            />
            <small className="text-red-600">
              <ErrorMessage name="password" />
            </small>
          </div>

          <div>
            <button
              type="submit"
              className="btn btn-primary group relative w-full"
            >
              <span className="absolute inset-y-0 left-0 flex items-center pl-3">
                <LockClosedIcon
                  className="h-5 w-5 text-white group-hover:text-light"
                  aria-hidden="true"
                />
              </span>
              Je me connecte
            </button>

            <Link to="/register">
              <span className="btn btn-third-outline mt-3 group py-2 relative w-full">
                Pas de Compte? Je m'inscris..
              </span>
            </Link>
          </div>

          <Link to="/forgot-password">
            <small className="mt-3  py-2 text-primary text-right ">
              Mot de passe oublié ?
            </small>
          </Link>

          {isLoggedIn && (
            <div className="flex justify-center">
              <small className="text-sm italic text-red-600">
                Vous devez vérifier votre e-mail avant de vous connecter.
              </small>
            </div>
          )}
        </Form>
      </Formik>
    </div>
  );
};

export default Login;
